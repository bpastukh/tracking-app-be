<?php

declare(strict_types=1);

namespace App\TaskModule\Domain\Report\ReportFormatter;

use App\TaskModule\Domain\Report\Report;
use App\TaskModule\Domain\Report\ReportDateRange;
use App\TaskModule\Domain\Report\ReportFormat;
use App\TaskModule\Domain\Task;
use DOMDocument;
use Dompdf\Dompdf;
use Dompdf\Options;

final class PDFReportFormatter implements ReportFormatter
{
    public function generate(array $tasks, ReportDateRange $dateRange): Report
    {
        $html = $this->prepareHtml($tasks, $dateRange);
        $output = $this->covertHtmlToPdf($html);

        return Report::create($output, $this->format());
    }

    public function format(): ReportFormat
    {
        return ReportFormat::create(ReportFormat::PDF_FORMAT);
    }

    private function prepareHtml(array $tasks, ReportDateRange $dateRange): string
    {
        $dom = new DOMDocument('1.0', 'utf-8');
        $header = $dom->createElement(
            'h1',
            "{$dateRange->dateFrom()->format('Y-m-d H:i:s')}
             - {$dateRange->dateTo()->format('Y-m-d H:i:s')}"
        );

        $dom->appendChild($header);

        $table = $dom->createElement('table');
        $table->setAttribute('border', '1');
        $tr = $dom->createElement('tr');
        $tr->appendChild($dom->createElement('th', 'Title'));
        $tr->appendChild($dom->createElement('th', 'Comment'));
        $tr->appendChild($dom->createElement('th', 'Created at'));
        $tr->appendChild($dom->createElement('th', 'Duration'));
        $table->appendChild($tr);

        $totalTime = 0;
        /** @var Task $task */
        foreach ($tasks as $task) {
            $totalTime += $task->loggedTime()->asNumber();

            $row = $dom->createElement('tr');
            $row->appendChild($dom->createElement('td', $task->title()->asString()));
            $row->appendChild($dom->createElement('td', $task->comment()->asString()));
            $row->appendChild($dom->createElement('td', $task->createdAt()->format('Y-m-d H:i:s')));
            $row->appendChild($dom->createElement('td', (string) $task->loggedTime()->asNumber()));

            $table->appendChild($row);
        }

        $totalTimeRow = $dom->createElement('tr');
        $td = $dom->createElement('td');
        $td->setAttribute('colspan', '3');
        $totalTimeRow->appendChild($td);
        $totalTimeRow->appendChild($dom->createElement('td', "Total: $totalTime"));
        $table->appendChild($totalTimeRow);

        $dom->appendChild($table);

        return $dom->saveHTML();
    }

    private function covertHtmlToPdf(string $html): string
    {
        $options = new Options();
        $options->set('defaultFont', 'Roboto');

        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        /** @var string $output */
        $output = $dompdf->output();

        return $output;
    }
}
