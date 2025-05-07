import React from "react";
import ReviewsSection from "../components/ReviewsSection";
import Review from "../components/Review";
import { reviews } from "../data";

const Reviews = () => {
  return (
    <main class="wrapper">
      <section>
        <div class="catalog-container">
          <h2>Отзывы</h2>
          <div class="catalog">
            {reviews &&
              reviews.length > 0 &&
              reviews.map((r, i) => <Review {...r} key={i} />)}
          </div>
        </div>
      </section>
    </main>
  );
};

export default Reviews;
