import { Navigate, Outlet } from "react-router-dom";
import { useStateContext } from "../../contexts/ContextProvider";

export default function Guestlayout() {
    const {token} =  useStateContext()
    if(token){
        return <Navigate to="/"/>
    }
    return (
        <div>
            <Outlet/>
        </div>
    )
}