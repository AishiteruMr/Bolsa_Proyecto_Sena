@if(isset($breadcrumbs) && count($breadcrumbs) > 0)
<nav class="breadcrumbs" style="display:flex;align-items:center;gap:8px;font-size:13px;margin-bottom:20px;flex-wrap:wrap;">
    @foreach($breadcrumbs as $i => $crumb)
        @if($i > 0)
            <i class="fas fa-chevron-right" style="font-size:10px;color:#94a3b8;"></i>
        @endif
        @if(isset($crumb['url']))
            <a href="{{ $crumb['url'] }}" style="color:#64748b;text-decoration:none;font-weight:600;transition:color 0.2s;padding:4px 8px;border-radius:6px;background:{{ $i === 0 ? '#f1f5f9' : 'transparent' }};" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='#64748b'">{{ $crumb['label'] }}</a>
        @else
            <span style="color:var(--primary);font-weight:800;">{{ $crumb['label'] }}</span>
        @endif
    @endforeach
</nav>
@endif
