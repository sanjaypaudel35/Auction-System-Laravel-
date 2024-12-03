<div class="pt-3 mb-3 d-flex justify-content-between" style="border-bottom: 2px solid #dfdfe7;">
    <div style="font-size: 24px;">{{$slot}}</div>
        @if(isset($rightSideContent))
            <div>{{$rightSideContent}}</div>
        @endif
</div>