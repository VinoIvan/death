<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Отображение страницы контактов
     */
    public function index()
    {
        $contacts = Contact::active()
            ->orderBy('sort_order')
            ->get()
            ->groupBy('type');
        
        return view('client.contacts.index', compact('contacts'));
    }

    /**
     * Отправка сообщения из формы обратной связи
     */
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string|max:1000',
        ]);

        // Адрес для отправки
        $toEmail = 'aamon160061@gmail.com';
        
        // Данные для письма
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'userMessage' => $request->message,
            'date' => now()->format('d.m.Y H:i'),
        ];

        try {
            // Отправка письма
            Mail::send('emails.contact', $data, function ($message) use ($toEmail, $data) {
                $message->to($toEmail)
                        ->subject('Новое сообщение с сайта VCM Laser')
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });

            return redirect()->route('contacts')->with('success', 'Сообщение успешно отправлено! Мы свяжемся с вами в ближайшее время.');
            
        } catch (\Exception $e) {
            // Логируем ошибку
            \Log::error('Ошибка отправки письма: ' . $e->getMessage());
            
            return redirect()->route('contacts')->with('error', 'Произошла ошибка при отправке. Пожалуйста, попробуйте позже.');
        }
    }
}