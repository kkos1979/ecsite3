<?php

namespace App\Mail;

use Illuminate\Http\Request; // 追加
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    // 追加
    public $request;
    public $rows;
    public $sum;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Request $request, $rows, $sum)
    {
        //
        $this->request = $request;
        $this->rows = $rows;
        $this->sum = $sum;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.orders.shipped');
    }
}
