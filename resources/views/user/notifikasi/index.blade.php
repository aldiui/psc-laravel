@forelse ($notifikasis as $notifikasi)
    <a @if ($notifikasi->status == '0') href="javascript:void(0)" onclick="updateStatusNotifikasi('{{ $notifikasi->url }}', '{{ $notifikasi->id }}')" @else href="{{ $notifikasi->url }}" @endif
        class="dropdown-item text-dark {{ $notifikasi->status == '1' ? 'dropdown-item-unread' : 'bg-light bg-opacity-75' }}">
        <div class="dropdown-item-icon {{ $notifikasi->title == 'Stok' ? 'bg-success' : 'bg-info' }} text-white">
            <i class="{{ $notifikasi->title == 'Stok' ? 'fas fa-clipboard-list' : 'fas fa-calendar' }}"></i>
        </div>
        <div class="dropdown-item-desc">
            {{ $notifikasi->body }}
            <div class="time text-primary text-capitalize">{{ $notifikasi->created_at->diffForHumans() }}</div>
        </div>
    </a>
@empty
    <div class="text-center">
        <div class="mb-2">
            <i class="fas fa-bell-slash text-secondary"></i>
        </div>
        <div class="small text-muted">Tidak ada notifikasi</div>
    </div>
@endforelse
