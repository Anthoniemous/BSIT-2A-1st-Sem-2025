  
  
  
  /**
   
        FOR HTML
   <script src="login.js"></script>
   
   */
  
  
  // Utility to handle storage
const StorageManager = {
    getUsers: () => JSON.parse(localStorage.getItem('users')) || [],
    setUsers: (users) => localStorage.setItem('users', JSON.stringify(users)),
    getAdmins: () => JSON.parse(localStorage.getItem('admins')) || [],
    setAdmins: (admins) => localStorage.setItem('admins', JSON.stringify(admins)),
    setCurrentUser: (user) => {
        // Remove sensitive information before storing
        const userInfo = {
            username: user.username,
            email: user.email,
            role: user.role,
            loginTime: new Date().toISOString()
        };
        localStorage.setItem('currentUser', JSON.stringify(userInfo));
    },
    clearCurrentUser: () => localStorage.removeItem('currentUser')
};



// Toggle forms
function toggleForm(section) {
    document.querySelectorAll('.form-section').forEach(sec => sec.classList.remove('active'));
    document.getElementById(`${section}-section`).classList.add('active');
}



// User Registration
document.getElementById('user-register-form').addEventListener('submit', function (e) {
    e.preventDefault();

    const username = document.getElementById('user-register-username').value.trim();
    const email = document.getElementById('user-register-email').value.trim();
    const password = document.getElementById('user-register-password').value;
    const confirmPassword = document.getElementById('user-register-confirm-password').value;

    if (password !== confirmPassword) {
        alert('Passwords do not match');
        return;
    }

    const users = StorageManager.getUsers();

    if (users.some(user => user.username === username || user.email === email)) {
        alert('Username or email already exists');
        return;
    }

    const newUser = { 
        username, 
        email, 
        password,
        role: 'user',
        registrationDate: new Date().toISOString()
    };
    
    users.push(newUser);
    StorageManager.setUsers(users);
    alert('User registered successfully');
    toggleForm('user-login');
});

// User Login
document.getElementById('user-login-form').addEventListener('submit', function (e) {
    e.preventDefault();

    const username = document.getElementById('user-login-username').value.trim();
    const password = document.getElementById('user-login-password').value;

    const users = StorageManager.getUsers();
    const user = users.find(u => u.username === username && u.password === password);

    if (!user) {
        alert('Invalid username or password');
        return;
    }

    // Store current user info
    StorageManager.setCurrentUser({
        username: user.username,
        email: user.email,
        role: 'user'
    });

    alert('Login successful');
    window.location.href = 'index.html';
});
