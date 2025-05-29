import React, { useState, useContext } from "react";
const SearchContext = React.createContext();
const MenuContext = React.createContext();
export const useSearchHistory = () => {
  return useContext(SearchContext);
};

export const useMenu = () => {
  return useContext(MenuContext);
};
export default function ({ children }) {
  const [value, setValue] = useState("");
  const [show, setShow] = useState(false);

  return (
    <MenuContext.Provider value={{ show, setShow }}>
      <SearchContext.Provider value={{ value, setValue }}>
        {children}
      </SearchContext.Provider>
    </MenuContext.Provider>
  );
}
