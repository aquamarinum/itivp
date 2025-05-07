import React from "react";
import Review from "./Review";
import { Link } from "react-router-dom";

const ReviewsSection = ({ reviews }) => {
  return (
    <section>
      <div className="content content-center">
        <h2>Отзывы</h2>
        <div className="preview">
          {reviews &&
            reviews.length > 0 &&
            reviews.slice(0, 3).map((r, i) => <Review {...r} key={i} />)}
        </div>
        <Link to="/reviews" className="button filled">
          Все отзывы
        </Link>
      </div>
    </section>
  );
};

export default ReviewsSection;
