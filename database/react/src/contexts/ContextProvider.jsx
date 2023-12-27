import { createContext,useContext,useState } from "react";

const StateContext = createContext({
    currentUser: null,
    token:null,
    catalog:null,
    setUser:()=>{},
    setToken:()=>{},
    setCatalog:()=>{}
})

export const ContextProvider = ({children}) => {
    const [catalog,setCatalog]=useState({});
    const [user,setUser]=useState({});
    const [token, _setToken]= useState(localStorage.getItem('ACCESS_TOKEN'));

    const setToken = (token)=> {
        _setToken(token)
        if(token){
            localStorage.setItem('ACCESS_TOKEN',token);
        }else {
            localStorage.removeItem('ACCESS_TOKEN');
        }
    }

    return (
        <StateContext.Provider value={{
            user,
            token,
            catalog,
            setUser,
            setToken,
            setCatalog
        }}>
            {children}
        </StateContext.Provider>
    )
}

export const useStateContext = () => useContext(StateContext)