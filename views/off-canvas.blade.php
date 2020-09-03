<div class="lit-off-canvas lit-off-canvas--{{ $direction }} {{ $class }}" id="{{ $id }}">
{{ $slot }}
</div>

<x-style lang="scss">

    .lit-off-canvas {
        position:fixed;
        top:0;
        left:0;
        width:100vw;
        height:100vh;
        transition:all 0.3s;
        background:white;
        text-align:center;
        &.lit-off-canvas--rtl {
            transform:translate(100%,0);
        }
        &.lit-off-canvas--ltr {
            transform:translate(-100%,0);
        }
        &.lit-off-canvas--ttb {
            transform:translate(0,-100%);
        }
        &.lit-off-canvas--btt {
            transform:translate(0,100%);
        }
        &.lit--visible {
            transform:translate(0,0) !important;
        }
    }

</x-style>