import React from 'react';
import './Header.css';

const Header = ({ setPage, setModalBox }) => {
  const isAuthenticated = !!localStorage.getItem('token');

  return (
    <div className="Header">
      <ul>
        <li onClick={() => setPage('Main')}>Главная</li>
        <li onClick={() => setPage('Basket')}>Корзина</li>
        {isAuthenticated && (
          <li onClick={() => setPage('Profile')}>Личный кабинет</li>
        )}
        <li onClick={() => setModalBox('Login')}>Вход</li>
        <li onClick={() => setModalBox('Registration')}>Регистрация</li>
      </ul>
    </div>
  );
};

export default Header;