import React from "react";
import IntroSection from "../components/IntroSection";
import AboutSection from "../components/AboutSection";
import MenuSection from "../components/MenuSection";
import ReviewsSection from "../components/ReviewsSection";
import ContactsSection from "../components/ContactsSection";
import OrderForm from "../components/OrderForm";
import { pizzas, reviews } from "../data";

const Home = () => {
  return (
    <main className="wrapper">
      <IntroSection />
      <AboutSection />
      <MenuSection pizzas={pizzas} />
      <ReviewsSection reviews={reviews} />
      <ContactsSection />
      <OrderForm />
    </main>
  );
};

export default Home;
