import { Link, Navigate, Outlet } from "react-router-dom";
import { useStateContext } from "../../contexts/ContextProvider";
import { useEffect } from "react";
import axiosClient from "../../axios-client";

export default function DefaultLayout() {
    const {user,token, setUser,setToken} = useStateContext()

    if(!token){
        return <Navigate to="/login"/>
    }

    const onLogout = (ev)=> {
        ev.preventDefault()
        axiosClient.post('/logout')
        .then(()=>{
            setUser({})
            setToken(null)
        })
    }

    useEffect (()=>{
        axiosClient.get('/user')
        .then(({data})=>{
            setUser(data)
        })
    },[])

    return (
        <div id="defaultLayout">
            <aside>
                <Link to="/" className="title_logo">EMPTY</Link>
                <Link to="/dashboard">Панель</Link>
                <Link to="/advertisements">Объявления</Link>
            </aside>
            <div className="content">
                <header>
                    <div>
                        
                    </div>
                    <div>
                        {user.name}
                        <a href="#" className="btn-logout" onClick={onLogout}>Logout</a>
                    </div>
                </header>
                <main>
                    <Outlet/>
                </main>
            </div>
        </div>
    )
}