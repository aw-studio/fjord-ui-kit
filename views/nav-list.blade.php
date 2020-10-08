<nav class="lit-nav-list 
@if($class) {{ $class }} @endif
@if($layout == 'horizontal') lit-nav-list--horizontal @endif
@if($expandable) lit-nav-list--expandable @endif 
@if($dropdown) lit-nav-list--dropdown @endif
">
   <ul>
    @include('bladesmith::partials.nav_level',[
        'items' => $list,
        'active_class' => $active_class,
        ])
    {{ $slot }}
   </ul>
</nav>

<x-style lang="scss">
    .lit-nav-list {
        a.lit--active {
            font-weight:bold;
        }
    }

    /* Horizontal List */
    .lit-nav-list.lit-nav-list--horizontal {
        ul {
            display:flex;
            li {
                margin-right:30px;
            }
            ul {
                display:block;
            }
        }
    }


    /* Dropdown */
    .lit-nav-list.lit-nav-list--dropdown {
        ul {
            li {
                position:relative;
                &:hover {
                    ul {
                        max-height:500px;
                        pointer-events:all;
                        opacity:1;
                    }
                }
            }
            ul {
                position:absolute;
                top:100%;
                left:0;
                max-height:0;
                opacity:0;
                pointer-events:none;
                transition:all 0.3s ease-in-out;
                background:white;
                ul {
                    max-width:0 !important;
                    opacity:0 !important;
                    position:absolute;
                    top:0;
                    left:100%;
                }
                li {
                    &:hover {
                        ul {
                            max-width:500px !important;
                            pointer-events:all !important;
                            opacity:1 !important;
                        }
                    }
                }
            }

        }
    }


    /* Expandeble List */
    .lit-nav-list.lit-nav-list--expandable {
        li {
            position:relative;
            margin:2px 0 2px 0;
        }
        ul {
            ul {
                max-height:0;
                opacity:0;
                transition:all 0.3s ease-in-out;
                overflow:hidden;
                &.lit--expand {
                    max-height:500px;
                    pointer-events:all;
                    opacity:1;
                }
            }
        }
    }
    button.lit-nav-list__expand {
        position:absolute;
        top:0;
        right:0;
        min-height:16px;
        min-width:16px;
        cursor:pointer;
        background: white url("data:image/svg+xml,%3C%3Fxml version='1.0' encoding='UTF-8'%3F%3E%3Csvg width='10px' height='7px' viewBox='0 0 10 7' version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'%3E%3Cg id='Page-1' stroke='none' stroke-width='1' fill='none' fill-rule='evenodd'%3E%3Cg transform='translate(-430.000000, -236.000000)' stroke='%23000000' stroke-width='2'%3E%3Cpolyline points='431 237 435 241 439 237'%3E%3C/polyline%3E%3C/g%3E%3C/g%3E%3C/svg%3E") no-repeat center center;
        &.lit--close {
            transform:rotate(180deg);
        }
    }
</x-style>

<x-script>
    const expandButtons = document.querySelectorAll("button.lit-nav-list__expand")

    for (const button of expandButtons) {
      button.addEventListener('click', function(event) {
        this.classList.toggle('lit--close')
        this.nextElementSibling.classList.toggle('lit--expand')
      })
    }
</x-script>





