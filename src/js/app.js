document.addEventListener("DOMContentLoaded", () => {
    const navLinks = document.querySelectorAll(".nav-link");
    const sections = document.querySelectorAll(".section");

    navLinks.forEach(link => {
        link.addEventListener("click", (e) => {
            e.preventDefault();

            
            navLinks.forEach(link => link.classList.remove("active"));

            
            link.classList.add("active");

            
            sections.forEach(section => section.classList.remove("active"));

            
            const sectionId = link.getAttribute("data-section");
            document.getElementById(sectionId).classList.add("active");
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth', 
        headerToolbar: {
            left: 'prev,next today', 
            center: 'title',         
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: [
            {
                title: 'Doctor Appointment',  
                start: '2024-11-25',
            },
        ],
        contentHeight: 'auto', 
        aspectRatio: 1.35,    
        editable: true,        
        dayMaxEvents: true,   
    });

    calendar.render();
});

function logout() {
    if(confirm("Are you sure you want to logout?")) {
        location.href = "../../dashboard_admin/admin/authentication_user/admin-class.php?btn-admin-signout";
    }
}