<div class="fj-off-canvas" id="fj-burger-target">
Off canvas
{{ $slot }}
</div>

<x-style lang="scss">

    .fj-off-canvas {
        position:fixed;
        left:100vw;
        top:0;
        width:100vw;
        height:100vh;
        transition:all 0.3s;
        background:white;
        text-align:center;
        &.fj--visible {
            left:0;
        }
    }

</x-style>