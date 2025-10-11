<style>
    /* .loader {
        width: 16px;
        height: 16px;
        box-shadow: 0 30px, 0 -30px;
        border-radius: 4px;
        background: currentColor;
        display: block;
        position: relative;
        transform: translate(-150%, -20px);
        color: #FFF;
        box-sizing: border-box;
        animation: animloader 2s ease infinite;
    }

    .loader::after,
    .loader::before {
        content: '';
        box-sizing: border-box;
        width: 16px;
        height: 16px;
        box-shadow: 0 30px, 0 -30px;
        border-radius: 4px;
        background: currentColor;
        color: #FFF;
        position: absolute;
        left: 30px;
        top: 0;
        animation: animloader 2s 0.2s ease infinite;
    }

    .loader::before {
        animation-delay: 0.4s;
        left: 60px;
    }

    @keyframes animloader {
        0% {
            top: 0;
            color: white;
        }

        50% {
            top: 30px;
            color: rgba(0, 0, 0, 0.2);
        }

        100% {
            top: 0;
            color: white;
        }
    } */

     /* From Uiverse.io by catraco */ 
.loader {
  --color: #a5a5b0;
  --size: 50px;
  width: var(--size);
  height: var(--size);
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 2px;
}

.loader span {
  width: 100%;
  height: 100%;
  background-color: var(--color);
  animation: keyframes-blink .5s alternate infinite linear;
}

.loader span:nth-child(1) {
  animation-delay: 0ms;
}

.loader span:nth-child(2) {
  animation-delay: 150ms;
}

.loader span:nth-child(3) {
  animation-delay: 150ms;
}

.loader span:nth-child(4) {
  animation-delay: 280ms;
}

@keyframes keyframes-blink {
  0% {
    opacity: 0.5;
    transform: scale(0.5) rotate(20deg);
  }

  50% {
    opacity: 1;
    transform: scale(1);
  }
}
</style>


<div id="loader" class="fixed z-50 inset-0 flex justify-center items-center flex-col bg-gray-50 dark:bg-gray-900">
    <div class="loader">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
    <div class="mt-5 dark:text-white">
        <p class="animate-pulse text-lg tracking-wide" id="loader-text">Cargando vista...</p>
    </div>
    
</div>


{{-- /* From Uiverse.io by alexruix */  --}}

{{-- <div  class="fixed z-30 inset-0 flex  justify-center items-center bg-gray-900/70 dark:bg-gray-900/70">
    <div  class="loader">
      <span class="loader-text" id="loader-text">Cargando los eventos</span>
        <span class="load"></span>
    </div>
</div> --}}
