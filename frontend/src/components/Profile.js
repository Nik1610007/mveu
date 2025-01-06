import React, { useState, useEffect } from 'react';
import axios from 'axios';
import './Profile.css';

const Profile = ({ setModalBox }) => {
  const [user, setUser] = useState({ login: '', email: '' });
  const [editMode, setEditMode] = useState(false);
  const [newPassword, setNewPassword] = useState('');
  const [confirmPassword, setConfirmPassword] = useState('');
  const [error, setError] = useState('');

  useEffect(() => {
    const token = localStorage.getItem('token');
    if (!token) {
      setModalBox('Login');
      return;
    }

    axios.get('http://localhost:9001/profile', {
      headers: { Authorization: `Bearer ${token}` }
    })
    .then(response => setUser(response.data))
    .catch(error => console.log(error));
  }, [setModalBox]);

  const handleSave = () => {
    if (newPassword !== confirmPassword) {
      setError('Пароли не совпадают');
      return;
    }

    const token = localStorage.getItem('token');
    const updatedData = { login: user.login, email: user.email };

    if (newPassword) {
      updatedData.password = newPassword;
    }

    axios.put('http://localhost:9001/profile', updatedData, {
      headers: { Authorization: `Bearer ${token}` }
    })
    .then(response => {
      setEditMode(false);
      setNewPassword('');
      setConfirmPassword('');
      setError('');
      alert('Данные успешно обновлены!');
    })
    .catch(error => console.log(error));
  };

  return (
    <div className="Profile">
      <h1>Личный кабинет</h1>
      {editMode ? (
        <div className="Profile-edit">
          <input
            value={user.login}
            onChange={(e) => setUser({ ...user, login: e.target.value })}
            placeholder="Логин"
          />
          <input
            value={user.email}
            onChange={(e) => setUser({ ...user, email: e.target.value })}
            placeholder="Email"
          />
          <input
            type="password"
            value={newPassword}
            onChange={(e) => setNewPassword(e.target.value)}
            placeholder="Новый пароль"
          />
          <input
            type="password"
            value={confirmPassword}
            onChange={(e) => setConfirmPassword(e.target.value)}
            placeholder="Повторите пароль"
          />
          {error && <p style={{ color: 'red' }}>{error}</p>}
          <button onClick={handleSave}>Сохранить</button>
        </div>
      ) : (
        <div className="Profile-info">
          <p><strong>Логин:</strong> {user.login}</p>
          <p><strong>Пароль:</strong></p> {}
          <p><strong>Email:</strong> {user.email}</p>
          <button onClick={() => setEditMode(true)}>Редактировать</button>
        </div>
      )}
    </div>
  );
};

export default Profile;