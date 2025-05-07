import React from "react";
import { useCart } from "../utils/useCart";

const Product = ({ pizza }) => {
  const { addToCart, removeFromCart, isInCart } = useCart();
  const current = isInCart(pizza.id);

  return (
    <div className="product">
      <div className="product-image">
        <a href="#">
          <img src={pizza.image} alt="product-image" />
        </a>
      </div>
      <div className="product-content">
        <h5>{pizza.title}</h5>
        <p>{pizza.description}</p>
        <div className="product-actions">
          <div className="price">
            от <span>{pizza.price} BYN</span>
          </div>
          {current ? (
            <>
              <button onClick={() => removeFromCart(current.id)}>-</button>
              <span>{current.count}</span>
              <button onClick={() => addToCart(current)}>+</button>
            </>
          ) : (
            <button onClick={() => addToCart(pizza)}>
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                <path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 144L48 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l144 0 0 144c0 17.7 14.3 32 32 32s32-14.3 32-32l0-144 144 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-144 0 0-144z" />
              </svg>
              Добавить
            </button>
          )}
        </div>
      </div>
    </div>
  );
};

export default Product;
