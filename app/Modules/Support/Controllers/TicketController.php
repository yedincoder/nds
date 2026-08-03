<?php

namespace App\Modules\Support\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class TicketController extends BaseController
{
    public function index(): string
    {
        $db = \Config\Database::connect();
        $tickets = $db->table('tickets')
            ->select('tickets.*, u.username')
            ->join('users u', 'u.id = tickets.user_id', 'left')
            ->orderBy('tickets.created_at', 'DESC')
            ->get()
            ->getResult();

        $data = [
            'title' => 'Support Tickets',
            'tickets' => $tickets,
        ];

        return view('Dashboard/support', $data);
    }

    public function create()
    {
        if ($this->request->getMethod() === 'post') {
            $validation = $this->validate([
                'category_id' => 'required|exists:categories,id',
                'subject' => 'required|min_length[5]|max_length[255]',
                'message' => 'required|min_length[10]',
            ]);

            if (!$validation) {
                return redirect()->back()
                    ->with('errors', $this->validator->getErrors())
                    ->withInput();
            }

            $ticketNumber = 'TKT-' . date('Ymd') . '-' . strtoupper(uniqid());

            $db = \Config\Database::connect();
            $db->table('tickets')->insert([
                'user_id' => session()->get('user_id') ?? 1,
                'category_id' => $this->request->getPost('category_id'),
                'ticket_number' => $ticketNumber,
                'subject' => $this->request->getPost('subject'),
                'message' => $this->request->getPost('message'),
                'status' => 'open',
                'priority' => 'normal',
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            return redirect()->to('/admin/support')
                ->with('success', 'Ticket created successfully.');
        }

        $db = \Config\Database::connect();
        $data = [
            'title' => 'Create New Ticket',
            'categories' => $db->table('categories')->get()->getResult(),
        ];

        return view('Dashboard/support_create', $data);
    }

    public function detail(string $ticketId)
    {
        $db = \Config\Database::connect();
        $ticket = $db->table('tickets')->where('id', $ticketId)->get()->getRow();

        if (!$ticket) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($this->request->getMethod() === 'post') {
            $db->table('ticket_replies')->insert([
                'ticket_id' => (int) $ticketId,
                'user_id' => session()->get('user_id') ?? 1,
                'message' => $this->request->getPost('message'),
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            return redirect()->to('/admin/support/ticket/' . $ticketId)
                ->with('success', 'Reply added successfully.');
        }

        $replies = $db->table('ticket_replies')
            ->select('r.*, u.username')
            ->join('users u', 'u.id = r.user_id', 'left')
            ->where('ticket_id', $ticketId)
            ->orderBy('r.created_at', 'ASC')
            ->get()
            ->getResult();

        $data = [
            'title' => 'Ticket #' . $ticket->ticket_number,
            'ticket' => $ticket,
            'replies' => $replies,
        ];

        return view('Dashboard/support_detail', $data);
    }

    public function close(string $ticketId)
    {
        $db = \Config\Database::connect();
        $db->table('tickets')->where('id', $ticketId)->update(['status' => 'closed']);

        return redirect()->to('/admin/support')
            ->with('success', 'Ticket closed successfully.');
    }
}
