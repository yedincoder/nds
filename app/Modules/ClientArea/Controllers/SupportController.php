<?php

namespace App\Modules\ClientArea\Controllers;

use App\Controllers\BaseController;
use App\Modules\Support\Services\SupportService;
use CodeIgniter\HTTP\ResponseInterface;

class SupportController extends BaseController
{
    protected SupportService $supportService;

    public function __construct()
    {
        $this->supportService = new SupportService();
    }

    /**
     * List user tickets
     */
    public function index()
    {
        $userId = session()->get('user_id');
        $result = $this->supportService->getTicketsByUser($userId);

        $data = [
            'title' => 'Support Tickets',
            'tickets' => $result['data']['tickets'] ?? [],
        ];

        return view('ClientArea/support/tickets', $data);
    }

    /**
     * Show create ticket form
     */
    public function create()
    {
        $data = [
            'title' => 'Create Ticket',
            'categories' => $this->getTicketCategories(),
        ];

        return view('ClientArea/support/create', $data);
    }

    /**
     * Store new ticket
     */
    public function store(): ResponseInterface
    {
        $validation = $this->validate([
            'category_id' => 'required|integer',
            'subject' => 'required|min_length[5]|max_length[255]',
            'message' => 'required|min_length[10]',
        ]);

        if (!$validation) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->withInput();
        }

        $result = $this->supportService->createTicket(session()->get('user_id'), [
            'category_id' => $this->request->getPost('category_id'),
            'subject' => $this->request->getPost('subject'),
            'message' => $this->request->getPost('message'),
            'priority' => $this->request->getPost('priority') ?? 'medium',
        ]);

        if (!$result['success']) {
            return redirect()->back()
                ->with('error', $result['message'])
                ->withInput();
        }

        return redirect()->to('client/support/tickets')
            ->with('success', 'Ticket berhasil dibuat.');
    }

    /**
     * Show ticket detail
     */
    public function detail(string $ref)
    {
        $ticket = $this->findTicketByIdentifier($ref);

        if (!$ticket) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Verify ticket belongs to user
        if ($ticket->user_id != session()->get('user_id')) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $result = $this->supportService->getTicketWithMessages($ticket->id);

        $data = [
            'title' => 'Ticket ' . $ticket->ticket_number,
            'ticket' => $result['data'] ?? $ticket,
        ];

        return view('ClientArea/support/detail', $data);
    }

    /**
     * Reply to ticket
     */
    public function reply(string $ref): ResponseInterface
    {
        $validation = $this->validate([
            'message' => 'required|min_length[10]',
        ]);

        if (!$validation) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->withInput();
        }

        $ticket = $this->findTicketByIdentifier($ref);

        if (!$ticket) {
            return redirect()->back()
                ->with('error', 'Ticket tidak ditemukan.');
        }

        // Verify ownership
        if ($ticket->user_id != session()->get('user_id')) {
            return redirect()->back()
                ->with('error', 'Anda tidak berhak membalas tiket ini.');
        }

        $result = $this->supportService->addMessage($ticket->id, session()->get('user_id'), [
            'message' => $this->request->getPost('message'),
        ]);

        if (!$result['success']) {
            return redirect()->back()
                ->with('error', $result['message'])
                ->withInput();
        }

        return redirect()->back()
            ->with('success', 'Balasan berhasil dikirim.');
    }

    /**
     * Close ticket
     */
    public function close(string $ref): ResponseInterface
    {
        $ticket = $this->findTicketByIdentifier($ref);

        if (!$ticket) {
            return redirect()->back()
                ->with('error', 'Ticket tidak ditemukan.');
        }

        if ($ticket->user_id != session()->get('user_id')) {
            return redirect()->back()
                ->with('error', 'Anda tidak berhak menutup tiket ini.');
        }

        $result = $this->supportService->closeTicket($ticket->id);

        if (!$result['success']) {
            return redirect()->back()
                ->with('error', $result['message']);
        }

        return redirect()->back()
            ->with('success', 'Ticket berhasil ditutup.');
    }

    /**
     * Get ticket categories
     */
    private function getTicketCategories(): array
    {
        $db = \Config\Database::connect();
        return $db->table('categories')
            ->where('type', 'ticket')
            ->orderBy('name', 'ASC')
            ->get()
            ->getResult();
    }

    /**
     * Find ticket by uuid, ticket_number, or id
     */
    private function findTicketByIdentifier(string $ref): ?object
    {
        $db = \Config\Database::connect();
        return $db->table('tickets')
            ->where('uuid', $ref)
            ->orWhere('ticket_number', $ref)
            ->orWhere('id', $ref)
            ->get()
            ->getRow();
    }
}