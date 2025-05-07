import React, { useEffect, useState } from "react";
import Product from "../components/Product";
import { useCart } from "../utils/useCart";

const Cart = () => {
  const { cart } = useCart();

  console.log(cart);

  return (
    <main className="wrapper">
      <section>
        <div className="catalog-container">
          {cart && cart.length > 0 ? (
            <>
              <h2>Корзина</h2>
              <div className="catalog">
                {cart.map((pizza) => (
                  <Product pizza={pizza} key={pizza.id} />
                ))}
              </div>
            </>
          ) : (
            <h2>К сожалению корзина пуста 😥</h2>
          )}
        </div>
      </section>
    </main>
  );
};

export default Cart;
