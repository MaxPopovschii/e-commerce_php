<?php

class NotificationController
{
    public function orderConfirmation($user_email, $order_id, $total)
    {
        $subject = "Conferma ordine #$order_id";
        $message = "Grazie per il tuo acquisto!\nIl tuo ordine #$order_id è stato ricevuto. Totale: €" . number_format($total, 2);
        $headers = "From: shop@example.com\r\n";
        mail($user_email, $subject, $message, $headers);
    }

    public function supportReply($user_email, $ticket_id, $reply)
    {
        $subject = "Risposta al ticket #$ticket_id";
        $message = "Hai ricevuto una risposta al tuo ticket di supporto:\n\n$reply";
        $headers = "From: support@example.com\r\n";
        mail($user_email, $subject, $message, $headers);
    }
}