@forelse ($notifikasis as $notifakasi)
    <a href="{{ $notifakasi->url }}" class="dropdown-item dropdown-item-unread">
        <div class="dropdown-item-icon {{ $notifakasi->title == 'Stok' ? 'bg-success' : 'bg-info' }} text-white">
            <i class="{{ $notifakasi->title == 'Stok' ? 'fas fa-clipboard-list' : 'fas fa-calendar' }}"></i>
        </div>
        <div class="dropdown-item-desc">
            {{ $notifakasi->body }}
            <div class="time text-primary">{{ $notifakasi->created_at->diffForHumans() }}</div>
        </div>
    </a>
@empty
@endforelse
