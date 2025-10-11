export const calendarFullScreen = (calendar)=>{

    const fullScreenButton = document.getElementById('calendar-full-screen');
    const closeFullScreenButton = document.getElementById('close-screen-full');
    const containerCalendar = document.getElementById('container-calendar');

    const manageFullScreen = ()=>{
        
        containerCalendar.classList.add('absolute','inset-0','z-20','bg-gray-800/60','h-screen','w-screen','md:p-10', 'p-2'); 
        containerCalendar.children[0].classList.add('bg-white','dark:bg-gray-800','p-5','rounded','h-full','w-full','flex','flex-col');        
        containerCalendar.children[0].children[0].classList.remove('hidden');
        calendar.setOption('height', '100%');
        calendar.updateSize();
    }

    const manageCloseFullScreen = ()=>{
        containerCalendar.classList.remove('absolute','inset-0','z-20','bg-gray-800/60','h-screen','w-screen','md:p-10', 'p-2'); 
        containerCalendar.children[0].classList.remove('bg-white','p-5','rounded','h-full','w-full','flex','flex-col');
        
        calendar.setOption('height', 'auto');
        calendar.updateSize();
        containerCalendar.children[0].children[0].classList.add('hidden');
    }

    const manageControlEnter = (e)=>{
        if(e.ctrlKey  && e.key === 'Enter'){
            e.preventDefault();
            manageFullScreen();
        }

        if(e.key === 'Escape'){
            e.preventDefault();
            manageCloseFullScreen();
        }
    }

    document.addEventListener('keydown', manageControlEnter);

    fullScreenButton.addEventListener('click', manageFullScreen);
    closeFullScreenButton.addEventListener('click', manageCloseFullScreen)
}