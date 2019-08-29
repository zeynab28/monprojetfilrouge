<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PdfController extends AbstractController
{
    /**
     * @Route("/pdf", name="pdf")
     */
    public function index()
    {
        $dompdf=new Dompdf();
       $dompdf->loadhtml("
       <h1>bonjour</h1>
       ");
       $dompdf->setPaper("A4","portrait");
       $dompdf->render();
       $dompdf->stream();
    }
}
