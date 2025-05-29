import React from "react";
import { useMenu } from "../ContextProvider/ContextProvider";
function HamburgerMenu() {
  const { setShow } = useMenu();
  const showBurgerMenu = () => {
    setShow(true);
  };
  return (
    <div className=" p-3 flex gap-2 flex-col" onClick={showBurgerMenu}>
      <span className=" w-8 block bg-black h-1 rounded-xl"></span>
      <span className=" w-8 h-1 block bg-black rounded-xl"></span>
      <span className=" block h-1 bg-black rounded-xl"></span>
    </div>
  );
}

export default HamburgerMenu;
