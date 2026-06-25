<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class PengajuanPeminjamanNotification extends Notification
{
    use Queueable;

    public function __construct(
        public $peminjaman
    ) {}

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type'          => 'pengajuan_peminjaman',
            'title'         => 'Pengajuan Peminjaman Baru',
            'message'       => ($this->peminjaman->pemohon->name ?? 'Pemohon') . ' mengajukan peminjaman ruangan.',
            'peminjaman_id' => $this->peminjaman->id,
            'no_peminjaman' => $this->peminjaman->no_peminjaman,
            'kegiatan'      => $this->peminjaman->kegiatan,
            'status'        => $this->peminjaman->status,
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
