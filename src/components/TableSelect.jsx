import React from "react";

export const TableSelect = ({ selectedTable, onSelect, error }) => {
  const tableNumbers = Array.from({ length: 20 }, (_, i) => i + 1);

  return (
    <div>
      <select
        value={selectedTable}
        onChange={(e) => onSelect(e.target.value)}
        required
      >
        <option value="">Выберите столик</option>
        {tableNumbers.map((number) => (
          <option key={number} value={number}>
            {number}
          </option>
        ))}
      </select>
      {error && <p className="error-message">{error}</p>}
    </div>
  );
};
