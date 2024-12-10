<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Метод для скачивания PDF
    public function downloadPdf($id)
    {
        // Получаем данные для конкретного заказа (Order)
        $order = Order::findOrFail($id);

        // Генерация PDF с использованием представления
        $pdf = PDF::loadView('pdf.orders', compact('order'));

        // Отправляем PDF на клиент для скачивания
        return $pdf->download("order_{$id}.pdf");
    }
}
