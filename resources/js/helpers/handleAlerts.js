const alerts = document.querySelectorAll('.alerts');
const time = 5000;

export const handleAlerts = ()=>{

    if(alerts.length === 0) return;

    alerts.forEach(alert => {
        setTimeout(() => {
            alert.classList.add('hidden');
        }, time);
    });

}