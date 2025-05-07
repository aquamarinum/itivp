// SearchBar.js
import React, { useState } from "react";

const SearchBar = ({ onFormSubmit }) => {
  const [term, setTerm] = useState("");

  const handleChange = (event) => {
    setTerm(String(event.target.value).trimStart());
  };

  const handleSubmit = (event) => {
    event.preventDefault();
    onFormSubmit(term);
  };

  return (
    <div className="search-bar ui segment">
      <form className="ui form" onSubmit={handleSubmit}>
        <div className="field">
          <label>Video Search</label>
          <input
            type="text"
            value={term}
            onChange={handleChange}
            maxLength={10}
          />
        </div>
      </form>
    </div>
  );
};

export default SearchBar;
