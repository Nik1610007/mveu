import React from 'react';
import './Product.css';

const Product = ({ header, image, price, addToBasket }) => {
  return (
    <div className="Product">
      <img src={image} alt={header} className="Product-image" />
      <h3>{header}</h3>
      <p>Цена: {price} руб.</p>
      <button onClick={addToBasket}>Добавить в корзину</button>
    </div>
  );
};

export default Product;