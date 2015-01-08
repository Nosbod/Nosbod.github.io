<?php

/**
 * Description of DispatchNote
 * @author Ian
 */
class DispatchNote {

    protected $api;
    protected $orders;
    protected $pdf;

    public function __construct(FwsApi $api, stdClass $orders, tFPDF $pdf) {
        $this->api = $api;
        $this->orders = $orders;
        $this->pdf = $pdf;
    }

    public function create() {
        //foreach ($this->orders->order as $order) {
            $details = $this->api->getOrderDetails($this->orders->order[0]);
            $this->createPage($details);
            $details = $this->api->getOrderDetails($this->orders->order[1]);
            $this->createPage($details);
        //}

        $this->pdf->Output();
    }

    protected function createPage($details)
    {
        foreach ($details->order->order as $order) {
            if ($order->delivery_address) {
                $deliveryAddress = $order->delivery_address;
            }

            if ($order->items) {
                $items = $order->items;
            }
        }

        $this->pdf->AddPage();
        // Add a Unicode font (uses UTF-8)
        $this->pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
        $this->pdf->AddFont('DejaVu','B','DejaVuSansCondensed-Bold.ttf',true);
        $this->pdf->SetFont('DejaVu','',12);
        $this->pdf->Write(4,"{$deliveryAddress->forename} {$deliveryAddress->surname}\n");
        $this->pdf->Write(4,"{$deliveryAddress->add1}\n");
        $this->pdf->Write(4,"{$deliveryAddress->add2}\n");
        $this->pdf->Write(4,"{$deliveryAddress->city}\n");
        $this->pdf->Write(4,"{$deliveryAddress->county}\n");
        $this->pdf->Write(4,"{$deliveryAddress->postcode}\n");
        $this->pdf->Ln(30);

        foreach($items as $item) {
            $this->pdf->SetFont('DejaVu','B',12);
            $this->pdf->Write(4,"{$item->description}\n");

            foreach ($item->options->options as $option) {
                $this->pdf->SetFont('DejaVu','',12);
                $this->pdf->Write(4,"{$option->customText}\n");
            }
        }
    }
}
