<?php
/**
 * Created by PhpStorm.
 * User: jose1805
 * Date: 7/08/18
 * Time: 12:40 PM
 */

namespace DogCat\Models;


use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Facades\Storage;

class Pdf extends Fpdf
{
    protected $width_page = 210;

    public $titulo = 'Dogcat';

    /*function __construct($orientation = 'P', $unit = 'mm', $size = 'A4')
    {
        parent::__construct($orientation, $unit, $size);
    }*/

    function __construct($titulo = 'Dogcat')
    {
        parent::__construct();
        $this->titulo = $titulo;
    }

    // Page header
    function Header()
    {
        // Logo
        $this->Image('imagenes/sistema/dogcat_md.png',10,10,30);
        // Arial bold 15
        $this->SetFont('Arial','B',22);
        // Move to the right
        $this->Cell(32);
        // Title
        $this->Cell(157,30,$this->titulo,0,0,'C');
        // Line break
        $this->Ln(40);
    }

// Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,utf8_decode('Página '.$this->PageNo()),0,0,'C');
    }

    public static function revision(RevisionPeriodica $revision, Mascota $mascota){

        $propietario = $mascota->user;
        $pdf = new Pdf(utf8_decode('REVISIÓN PERIODICA'));
        $tope = 250;
        $pdf->AddPage();

        //agregamos datos generales
        //datos del propietario
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->cell(30,10,'Propietario: ',1,0);
        $pdf->SetFont('Arial', '', 12);
        $pdf->cell(80,10,utf8_decode($propietario->fullName()),1,0);

        //fecha
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->cell(20,10,'Fecha: ',1,0);
        $pdf->SetFont('Arial', '', 12);
        $pdf->cell(60,10,date('Y-m-d',strtotime($revision->created_at)),1,1);

        //nombre mascota
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->cell(30,10,'Mascota: ',1,0);
        $pdf->SetFont('Arial', '', 12);
        $pdf->cell(80,10,utf8_decode($mascota->nombre),1,0);

        //raza
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->cell(20,10,'Raza: ',1,0);
        $pdf->SetFont('Arial', '', 12);
        $pdf->cell(60,10,utf8_decode($mascota->raza->nombre),1,1);

        //tipo
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->cell(30,10,'Tipo: ',1,0);
        $pdf->SetFont('Arial', '', 12);
        $pdf->cell(20,10,utf8_decode($mascota->raza->tipoMascota->nombre),1,0);

        //color
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->cell(20,10,'Color: ',1,0);
        $pdf->SetFont('Arial', '', 12);
        $pdf->cell(40,10,utf8_decode($mascota->color),1,0);

        //fecha nacimiento
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->cell(40,10,'Fecha nacimiento: ',1,0);
        $pdf->SetFont('Arial', '', 12);
        $pdf->cell(40,10,date('Y-m-d',strtotime($mascota->fecha_nacimiento)),1,1);

        //Quien realiza la revisión
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->cell(60,10,utf8_decode('Revisión realizada por: '),1,0);
        $pdf->SetFont('Arial', '', 12);
        $pdf->cell(130,10,utf8_decode($revision->usuario->fullName()),1,1);

        $pdf->SetFont('Arial', 'I', 10);
        $pdf->cell(190,10,utf8_decode('Nota: las evidencias guardadas en formato pdf no se visualizarán en este reporte.'),0,1);
        $pdf->Ln(3);
        $items = $revision->items;

        foreach ($items as $item) {
            if($pdf->GetY() >= $tope)
                $pdf->AddPage();

            $pdf->SetFillColor(66,133,244);
            $pdf->SetTextColor(255,255,255);
            $pdf->SetFont('Arial','B',14);
            $pdf->cell(190,10,utf8_decode(strtoupper($item->nombre)),1,1,'C',true);

            $pdf->SetFont('Arial','',12);
            $pdf->SetTextColor(0,0,0);

            $posicion_x = $pdf->GetX();
            $posicion_y = $pdf->GetY();

            $pdf->Ln(3);
            $pdf->MultiCell(190, 6, utf8_decode($item->observaciones), 0, 'J', false);
            $pdf->Ln(3);

            //dibujamos las evidencias si tiene
            $evidencias = $item->evidencias;
            if(count($evidencias)) {
                $dibujadas = 0;

                //cuenta los elementos de evidencia que se han dibuhado en linea
                $en_linea = 0;
                //altura de la imagen más gande
                $altura_mayor = 0;
                $indice = 0;
                foreach ($evidencias as $evidencia){
                    $indice++;
                    if($evidencia->mimeType() != 'pdf') {

                        if($dibujadas == 0){
                            $pdf->SetFont('Arial','B',12);
                            $pdf->cell(190, 10, 'Evidencias:', 0, 1);
                            $dibujadas = 1;
                        }

                        $url_file = storage_path('app/'.$evidencia->ubicacion.'/'.$evidencia->nombre);
                        $data_file = getimagesize($url_file);

                        //ancho de la imagen en el pdf
                        $ancho = 85;

                        //porcentaje en relacion al ancho original de la imagen
                        //y el ancho de la imagen en el pdf
                        $porcentaje_imagen = ($ancho * 100)/$data_file[0];

                        //nueva altura de la imagen en el pdf
                        $alto_imagen = ($data_file[1]*$porcentaje_imagen)/100;
                        $altura_mayor = $alto_imagen > $altura_mayor?$alto_imagen:$altura_mayor;
                        /*dd($data_file);
                        dd($alto_imagen);*/

                        //si al agregar la imagen se pasa del tope
                        //se agrega una nueva pagina para dibujar la imagen
                        if($pdf->GetY() + $alto_imagen >= $tope) {
                            //se dibuha el rectangulo que rodea el contenido final de la apagina
                            $pdf->Rect($posicion_x,$posicion_y,190,$pdf->GetY()-$posicion_y);

                            $pdf->AddPage();
                            //se reinician los valores de las siguientes variables
                            //para dibujar el rectangulo en la siguiente página
                            $posicion_y = $pdf->GetY()-5;
                            $posicion_x = $pdf->GetX();
                        }


                        if($en_linea == 1) {
                            $pdf->Image($url_file, 15+$ancho+(190-10-($ancho*2)), $pdf->GetY(), $ancho);
                            $pdf->SetY($pdf->GetY() + $altura_mayor);
                            $pdf->Ln(5);
                            $en_linea = 0;
                        }else {
                            $pdf->Image($url_file, 15, $pdf->GetY(), $ancho);
                            if($indice == count($evidencias)){
                                $pdf->SetY($pdf->GetY() + $altura_mayor);
                                $pdf->Ln(5);
                                $en_linea = 0;
                            }else {
                                $en_linea++;
                            }
                        }
                    }
                }
            }


            $pdf->Rect($posicion_x,$posicion_y,190,$pdf->GetY()-$posicion_y);
        }
        //$pdf->AddPage();
        $pdf->Output();
        exit;
    }

}