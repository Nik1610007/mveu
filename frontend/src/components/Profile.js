import React, { useState, useEffect } from 'react';
import axios from 'axios';
import './Profile.css';

const Profile = ({ setModalBox }) => {
  const [user, setUser] = useState({ login: '', email: '' });
  const [editMode, setEditMode] = useState(false);

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
    const token = localStorage.getItem('token');
    axios.put('http://localhost:9001/profile', user, {
      headers: { Authorization: `Bearer ${token}` }
    })
    .then(response => {
      setEditMode(false);
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
          <button onClick={handleSave}>Сохранить</button>
        </div>
      ) : (
        <div className="Profile-info">
          <p><strong>Логин:</strong> {user.login}</p>
          <p><strong>Email:</strong> {user.email}</p>
          <button onClick={() => setEditMode(true)}>Редактировать</button>
        </div>
      )}
    </div>
  );
};

export default Profile;