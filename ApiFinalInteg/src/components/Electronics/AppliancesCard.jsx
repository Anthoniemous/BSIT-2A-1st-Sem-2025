import React from "react";

function AppliancesCard({ title, price, image }) {
  return (
    <div className="flex flex-col items-center w-auto text-center  gap-5  border border-gray-200 rounded-xl p-5 h-[350px] justify-center">
      <img src={image} className="h-40 w-auto"></img>
      <div className="flex items-center gap-5 border border-gray-300 rounded-2xl p-1">
        <p className=" font-bold text-xs ">{title}</p>
        <div className="flex gap-5 flex-col bg-[#4F75E1] rounded-xl">
          <p className="font-300 text-white p-1  text-xs ">${price} usd</p>
        </div>
      </div>
    </div>
  );
}

export default AppliancesCard;
