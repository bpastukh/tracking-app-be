<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\ResponseCreator;
use App\TaskModule\Application\GenerateReportRequest;
use App\TaskModule\Application\GenerateReportService;
use Assert\InvalidArgumentException;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/api/report")
 */
final class ReportController
{
    /**
     * @Route(methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Returns file with generated report"
     *     )
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Bad request"
     *     )
     * )
     * @SWG\Parameter(
     *     name="format",
     *     in="query",
     *     type="string",
     *     required=true,
     *     description="Format to generate. Currently available: csv, pdf, xlsx"
     * )
     * @SWG\Parameter(
     *     name="date-from",
     *     in="query",
     *     type="string",
     *     required=true,
     *     description="Report's start date"
     * )
     * @SWG\Parameter(
     *     name="date-to",
     *     in="query",
     *     type="string",
     *     required=true,
     *     description="Report's finish date"
     * )
     */
    public function generate(
        Request $request,
        ResponseCreator $responseCreator,
        GenerateReportService $service
    ): Response {
        try {
            $format = $request->query->get('format');
            $dateFrom = $request->query->get('date-from');
            $dateTo = $request->query->get('date-to');
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
