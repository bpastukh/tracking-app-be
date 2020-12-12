<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\ResponseCreator;
use App\TaskModule\Application\GenerateReportRequest;
use App\TaskModule\Application\GenerateReportService;
use Assert\InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/api/report")
 */
final class ReportController
{
    /**
     * @Route(methods={"POST"})
     */
    public function generate(
        Request $request,
        ResponseCreator $responseCreator,
        GenerateReportService $service
    ): Response {
        try {
            $format = $request->request->get('format');
            $dateFrom = $request->request->get('dateFrom');
            $dateTo = $request->request->get('dateTo');
            $reportArray = $service->generate(new GenerateReportRequest($format, $dateFrom, $dateTo));
            $report = $reportArray['report'];
            $format = $reportArray['format'];

            return $this->prepareFileResponse($format, $report);
        } catch (InvalidArgumentException $exception) {
            return $responseCreator->create(['message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    private function prepareFileResponse($format, $report): Response
    {
        $filename = 'reports/'.uniqid('', true).'.'.$format;
        file_put_contents($filename, $report);

        $response = new Response();

        $this->sendHeaders($response, $filename);

        $response->setContent($report);

        unlink($filename);

        return $response;
    }

    private function sendHeaders(Response $response, string $filename): void
    {
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-type', mime_content_type($filename));
        $response->headers->set('Content-Disposition', 'attachment; filename="'.basename($filename).'";');
        $response->headers->set('Content-length', (string) filesize($filename));

        $response->sendHeaders();
    }
}
