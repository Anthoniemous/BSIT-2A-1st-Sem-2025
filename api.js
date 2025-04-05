const express = require('express');
const cors = require('cors');

const app = express();
const PORT = 3000;

app.use(cors());
app.use(express.json());

let users = [
    { id: 1, username: 'admin', email: 'admin@example.com' },
    { id: 2, username: 'sample', email: 'sampleLore@example.com' },
];
let settings = { siteName: 'My Dashboard', adminEmail: 'admin@example.com' };


app.get('/api/users', (req, res) => {
    res.json(users);
});


app.get('/api/users/:id', (req, res) => {
    const user = users.find(u => u.id === parseInt(req.params.id));
    if (user) {
        res.json(user);
    } else {
        res.status(404).json({ message: 'User not found' });
    }
});

app.delete('/api/users/:id', (req, res) => {
    const userId = parseInt(req.params.id);
    const userIndex = users.findIndex(u => u.id === userId);
    if (userIndex !== -1) {
        const deletedUser = users.splice(userIndex, 1);
        res.json({ message: 'User deleted successfully', user: deletedUser });
    } else {
        res.status(404).json({ message: 'User not found' });
    }
});

app.get('/api/statistics', (req, res) => {
    res.json({
        totalUsers: users.length,
        activeUsers: users.length - 1, 
        newRegistrations: 1,
    });
});

app.get('/api/settings', (req, res) => {
    res.json(settings);
});

app.post('/api/settings', (req, res) => {
    settings = { ...settings, ...req.body };
    res.json({ message: 'Settings updated successfully', settings });
});


app.post('/api/users', (req, res) => {
    const newUser = {
        id: users.length + 1,
        username: req.body.username,
        email: req.body.email,
    };
    users.push(newUser);
    res.json({ message: 'User added successfully', user: newUser });
});

app.listen(PORT, () => {
    console.log(`Server running on http://localhost:${PORT}`);
});
