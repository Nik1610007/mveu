import React, { useState, useEffect } from 'react';
import './Basket.css';
import ModalBox from '../components/ModalBox';

const Basket = () => {
  const [basket, setBasket] = useState([]);
  const [modalBox, setModalBox] = useState('none');
  const [cardNumber, setCardNumber] = useState('');
  const [cardExpiry, setCardExpiry] = useState('');
  const [cardCVC, setCardCVC] = useState('');

  useEffect(() => {
    const savedBasket = JSON.parse(localStorage.getItem('basket')) || [];
    setBasket(savedBasket);
  }, []);

  const removeFromBasket = (productId) => {
    const updatedBasket = basket.filter(item => item._id !== productId);
    setBasket(updatedBasket);
    localStorage.setItem('basket', JSON.stringify(updatedBasket));
  };

  const totalPrice = basket.reduce((sum, item) => sum + item.price, 0);

  const handleOrder = () => {
    setModalBox('order');
  };

  const submitOrder = () => {
    if (!cardNumber || !cardExpiry || !cardCVC) {
      alert('Заполните все поля!');
      return;
    }

    alert('Заказ успешно оформлен!');
    setBasket([]);
    localStorage.removeItem('basket');
    setModalBox('none');
  };

  return (
    <div className="Basket">
      <h1>Корзина</h1>
      {basket.length === 0 ? (
        <p>Ваша корзина пуста</p>
      ) : (
        <>
          <ul>
            {basket.map((item) => (
              <li key={item._id}>
                <img src={item.image} alt={item.header} className="Basket-image" />
                <div className="Basket-info">
                  <h3>{item.header}</h3>
                  <p>Цена: {item.price} руб.</p>
                </div>
                <button onClick={() => removeFromBasket(item._id)}>Удалить</button>
              </li>
            ))}
          </ul>
          <p>Общая сумма: {totalPrice} руб.</p>
          <button onClick={handleOrder}>Оформить заказ</button>
        </>
      )}

      {modalBox === 'order' && (
        <ModalBox setModalBox={setModalBox}>
          <h2>Оформление заказа</h2>
          <form>
            <input
              type="text"
              placeholder="Номер карты"
              value={cardNumber}
              onChange={(e) => setCardNumber(e.target.value)}
            />
            <input
              type="text"
              placeholder="Срок действия (MM/YY)"
              value={cardExpiry}
              onChange={(e) => setCardExpiry(e.target.value)}
            />
            <input
              type="text"
              placeholder="CVC/CVV"
              value={cardCVC}
              onChange={(e) => setCardCVC(e.target.value)}
            />
            <button type="button" onClick={submitOrder}>Подтвердить</button>
          </form>
        </ModalBox>
      )}
    </div>
  );
};

export default Basket;