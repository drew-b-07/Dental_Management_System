document.addEventListener("DOMContentLoaded", () => {
    const navLinks = document.querySelectorAll(".nav-link");
    const sections = document.querySelectorAll(".section");
    
    let calendarInitialized = false;

    navLinks.forEach(link => {
        link.addEventListener("click", (e) => {
            e.preventDefault();

            navLinks.forEach(nav => nav.classList.remove("active"));
            link.classList.add("active");

            sections.forEach(sec => sec.classList.remove("active"));
            document.getElementById(link.dataset.section).classList.add("active");
            const sectionId = link.getAttribute("data-section");
            const targetSection = document.getElementById(sectionId);

            targetSection.classList.add("active");

            if(link.getAttribute("data-section") === "appointments" && !calendarInitialized){
                initializeCalendar();
                calendarInitialized = true;
            } 
        });
    });

    initializePatientSection();
    initializeDashboard();
    flatpickr("#patient-birthday", { dateFormat: "Y-m-d"});
});


document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const section = urlParams.get("section");

    if (section) {
        // Remove 'active' class from all sections
        document.querySelectorAll(".section").forEach((sec) => {
            sec.classList.remove("active");
        });

        // Add 'active' class to the requested section
        const activeSection = document.getElementById(section);
        if (activeSection) {
            activeSection.classList.add("active");
        }

        // Update the sidebar link styles
        document.querySelectorAll(".nav-link").forEach((link) => {
            link.classList.remove("active");
        });

        const activeLink = document.querySelector(`.nav-link[data-section="${section}"]`);
        if (activeLink) {
            activeLink.classList.add("active");
        }
    }
});

function initializeCalendar() {
    const calendarEl = document.getElementById("calendar");
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: "dayGridMonth",
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay',
        },
        events: [
            { title: "John's Checkup", start: "2024-06-10" },
            { title: "Follow-up Meeting", start: "2024-06-12" },
            { title: "Doctor Appointment", start: "2024-11-25" }
        ],
        editable: true,
        dayMaxEvents: true,
    });
    calendar.render();
}

let patients = [];
function initializePatientSection() {
    const form = document.getElementById("patient-form");

    form.addEventListener("submit", handlePatientFormSubmit);

    renderPatientTable();
}

function handlePatientFormSubmit() {

    const patientIdField = document.getElementById("patient-id");
    const patientId = patientIdField.value ? parseInt(patientIdField.value, 10) : null;

    const patient = {
        name: document.getElementById("patient-name").value.trim(),
        age: parseInt(document.getElementById("patient-age").value.trim(), 10),
        birthday: document.getElementById("patient-birthday").value.trim(),
        gender: document.getElementById("patient-gender").value.trim(),
        email: document.getElementById("patient-email").value.trim(),
        address: document.getElementById("patient-address").value.trim(),
        condition: document.getElementById("patient-condition").value.trim(),
        contact: document.getElementById("patient-contact").value.trim(),
    };

    if (!patient.name || isNaN(patient.age) || !patient.birthday || !patient.condition) {
        alert("Please fill in all required fields.");
        return;
    }

    if (patientId !== null && patientId >= 0 && patientId < patients.length) {
        // Update existing patient
        patients[patientId] = patient;
    } else {
        // Add new patient
        patients.push(patient);
    }

    // // Clear the form and reset the patient ID
    // document.getElementById("patient-form").reset();
    // patientIdField.value = "";

    renderPatientTable();
    initializeDashboard();
}

function renderPatients() {
    const tbody = document.getElementById("patients-table");
    tbody.innerHTML = "";
    patients.forEach((p, i) => {
        tbody.innerHTML += `<tr>
            <td>${p.name}</td><td>${p.age}</td><td>${p.birthday}</td>
            <td>${p.gender}</td><td>${p.email}</td><td>${p.address}</td>
            <td>${p.condition}</td><td>${p.contact}</td>
            <td><button onclick="editPatient(${i})">Edit</button>
                <button onclick="deletePatient(${i})">Delete</button></td>
        </tr>`;
    });
}

function renderPatientTable() {
    const tbody = document.getElementById("patients-table");
    tbody.innerHTML = "";

    patients.forEach((patient, index) => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${patient.name}</td>
            <td>${patient.age}</td>
            <td>${patient.birthday}</td>
            <td>${patient.gender}</td>
            <td>${patient.email}</td>
            <td>${patient.address}</td>
            <td>${patient.condition}</td>
            <td>${patient.contact}</td>
            <td>
                <button onclick="editPatient(${index})">Edit</button>
                <button onclick="deletePatient(${index})">Delete</button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

function editPatient(index) {
if(confirm("Are you sure you want to edit this patient?")){
    const patient = patients[index];
    document.getElementById("patient-id").value = index;
    document.getElementById("patient-name").value = patient.name;
    document.getElementById("patient-age").value = patient.age;
    document.getElementById("patient-birthday").value = patient.birthday;
    document.getElementById("patient-gender").value = patient.gender;
    document.getElementById("patient-email").value = patient.email;
    document.getElementById("patient-address").value = patient.address;
    document.getElementById("patient-condition").value = patient.condition;
    document.getElementById("patient-contact").value = patient.contact;
}
}

function deletePatient(index) {
    if (confirm("Are you sure you want to delete this patient?")) {
        patients.splice(index, 1);
        renderPatientTable();
        initializeDashboard();
    }
}

function initializeDashboard() {
    document.getElementById("total-patients").innerText = patients.length;
    document.getElementById("upcoming-appointments").innerText = 2;
    document.getElementById("reports-count").innerText = 5;
}

function logout(){
    if(confirm("Are you sure you want to logout?")){
        location.href = "../../dashboard_admin/admin/authentication_admin/admin-class.php?admin_signout";
        
    }
}