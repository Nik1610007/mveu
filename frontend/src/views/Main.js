import React from 'react';
import './Main.css';
import Product from '../components/Product';

import asusImage from '../images/asus.jpg';
import lenovoImage from '../images/lenovo.jpg';
import hpImage from '../images/hp.jpg';
import samsungImage from '../images/samsung.jpg';
import xiaomiImage from '../images/xiaomi.jpg';
import appleImage from '../images/apple.jpg';

function Main() {
  const products = [
    {
      _id: 1,
      header: 'Ноутбук ASUS',
      price: 45000,
      image: asusImage,
    },
    {
      _id: 2,
      header: 'Ноутбук Lenovo',
      price: 42000,
      image: lenovoImage,
    },
    {
      _id: 3,
      header: 'Ноутбук HP',
      price: 48000,
      image: hpImage,
    },
    {
      _id: 4,
      header: 'Смартфон Samsung',
      price: 25000,
      image: samsungImage,
    },
    {
      _id: 5,
      header: 'Смартфон Xiaomi',
      price: 22000,
      image: xiaomiImage,
    },
    {
      _id: 6,
      header: 'Смартфон Apple',
      price: 30000,
      image: appleImage,
    },
  ];

  const addToBasket = (product) => {
    const savedBasket = JSON.parse(localStorage.getItem('basket')) || [];
    const updatedBasket = [...savedBasket, product];
    localStorage.setItem('basket', JSON.stringify(updatedBasket));
    alert('Товар добавлен в корзину!');
  };

  return (
    <div className="Main">
      <h1>Товары</h1>
      <div className="Product-list">
        {products.map((item) => (
          <Product
            key={item._id}
            header={item.header}
            image={item.image}
            price={item.price}
            addToBasket={() => addToBasket(item)}
          />
        ))}
      </div>
    </div>
  );
}

export default Main;