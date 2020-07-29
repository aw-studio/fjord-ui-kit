<div class="fj-off-canvas fj-off-canvas--{{ $direction }} {{ $class }}" id="{{ $target_id }}">
{{ $slot }}
</div>

<x-style lang="scss">

    .fj-off-canvas {
        position:fixed;
        top:0;
        left:0;
        width:100vw;
        height:100vh;
        transition:all 0.3s;
        background:white;
        text-align:center;
        &.fj-off-canvas--rtl {
            transform:translate(100%,0);
        }
        &.fj-off-canvas--ltr {
            transform:translate(-100%,0);
        }
        &.fj-off-canvas--ttb {
            transform:translate(0,-100%);
        }
        &.fj-off-canvas--btt {
            transform:translate(0,100%);
        }
        &.fj--visible {
            transform:translate(0,0) !important;
        }
    }

</x-style>