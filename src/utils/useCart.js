import React, {
  createContext,
  useContext,
  useState,
  useEffect,
  useCallback,
} from "react";

const CartContext = createContext();

export function CartProvider({ children }) {
  const [cart, setCart] = useState([]);

  useEffect(() => {
    const json = localStorage.getItem("itivp-cart");
    const data = JSON.parse(json);
    if (data) setCart(data);
  }, []);

  const saveCartToLocalStorage = useCallback(() => {
    localStorage.setItem("itivp-cart", JSON.stringify(cart));
  }, [cart]);

  useEffect(() => {
    window.addEventListener("beforeunload", saveCartToLocalStorage);
    return () => {
      window.removeEventListener("beforeunload", saveCartToLocalStorage);
      saveCartToLocalStorage();
    };
  }, [saveCartToLocalStorage]);

  const addToCart = (pizza) => {
    setCart((prevCart) => {
      const objIndex = prevCart.findIndex((product) => product.id === pizza.id);

      if (objIndex > -1) {
        const newCart = [...prevCart];
        newCart[objIndex].count++;
        return newCart;
      } else {
        const newObj = { ...pizza, count: 1 };
        const updatedCart = [...prevCart, newObj];
        return updatedCart;
      }
    });
  };

  const removeFromCart = (id) => {
    setCart((prevCart) => {
      const objIndex = prevCart.findIndex((product) => product.id === id);

      if (objIndex === -1) {
        return prevCart; // Ничего не делаем, если элемент не найден
      }

      const newCart = [...prevCart];

      if (newCart[objIndex].count > 1) {
        newCart[objIndex].count--;
        return newCart;
      } else if (newCart[objIndex].count === 1) {
        const filteredCart = newCart.filter((el) => el.id !== id);
        return filteredCart;
      }
      return prevCart; // В случае чего-то непредвиденного, возвращаем предыдущее состояние
    });
  };

  const isInCart = (id) => {
    if (cart && cart.length > 0) return cart.find((el) => el.id === id);
    return undefined;
  };

  const value = {
    cart,
    addToCart,
    removeFromCart,
    isInCart,
  };

  return <CartContext.Provider value={value}>{children}</CartContext.Provider>;
}

export function useCart() {
  return useContext(CartContext);
}
