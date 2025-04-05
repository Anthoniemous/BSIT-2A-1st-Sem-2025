
let users = [
    { id: 1, username: "admin", email: "admin@example.com", active: true },
    { id: 2, username: "sample", email: "sampleLore@example.com", active: false },
    { id: 3, username: "nana", email: "nana@example.com", active: false },
    
];


function renderUserTable() {
    const tbody = document.querySelector("#user-management tbody");
    tbody.innerHTML = ""; 
    users.forEach(user => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${user.id}</td>
            <td>${user.username}</td>
            <td>${user.email}</td>
            <td>
                <button onclick="deleteUser(${user.id})">Delete</button>
            </td>
        `;
        tbody.appendChild(row);
    });
}


function updateStatistics() {
    document.getElementById("total-users").textContent = users.length;
    document.getElementById("active-users").textContent = users.filter(user => user.active).length;
    document.getElementById("new-registrations").textContent = users.filter(user => !user.active).length;
}


function addUser(event) {
    event.preventDefault();
    const username = document.getElementById("new-username").value;
    const email = document.getElementById("new-email").value;

    if (username && email) {
        const newUser = {
            id: users.length + 1,
            username,
            email,
            active: false,
        };
        users.push(newUser);
        renderUserTable();
        updateStatistics();
        document.getElementById("add-user-form").reset();
    }
}

function deleteUser(userId) {
    users = users.filter(user => user.id !== userId);
    renderUserTable();
    updateStatistics();
}


document.addEventListener("DOMContentLoaded", () => {
    renderUserTable();
    updateStatistics();
    document.getElementById("add-user-form").addEventListener("submit", addUser);
});
