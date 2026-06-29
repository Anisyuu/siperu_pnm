<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class VerifikasiPeminjamanNotification extends Notification
{
    use Queueable;

    public function __construct(
        public $peminjaman,
        public string $statusVerifikasi
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type'              => 'verifikasi_peminjaman',
            'title'             => 'Status Peminjaman Diperbarui',
            'message'           => 'Pengajuan peminjaman Anda telah ' . $this->statusVerifikasi . '.',
            'peminjaman_id'     => $this->peminjaman->id,
            'no_peminjaman'     => $this->peminjaman->no_peminjaman,
            'kegiatan'          => $this->peminjaman->kegiatan,
            'status'            => $this->peminjaman->status,
            'status_verifikasi' => $this->statusVerifikasi,
        ];
    }
}