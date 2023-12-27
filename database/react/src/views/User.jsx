import { useEffect } from "react";
import { useState } from "react"
import axiosClient from "../axios-client";
import { Link } from "react-router-dom";

export default function Users() {
    const [catalog,setCatalog]= useState([]);
    const [loading,setLoading]= useState(false)

    useEffect(()=>{
        getCatalog();
    },[])

    const getCatalog = ()=> {
        setLoading(true)
        axiosClient.get('/advertisements')
        .then(({data})=> {
            setLoading(false)
            console.log(data);
            setCatalog(data.data)
        })
        .catch(()=>{
            setLoading(false)
        })
    }


    return (
        <div>
            <div style={{display:'flex',justifyContent:'space-between',alignItems:'center'}}>
                <h1>Объявления</h1>
                <Link to="/advertisements/store" className="btn-add">Создать новое обявление</Link>
            </div>
            <div className="card animated fadeInDown">
                <table>
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>title</th>
                            <th>Описание</th>
                            <th>Позиция</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        {catalog.map(u => (
                            <tr key={u.id}>
                                <td>{u.id}</td>
                                <td>{u.title}</td>
                                <td>{u.description}</td>
                                <td>{u.location}</td>
                                <td>
                                <Link className="btn btn-warning me-3" to={'/advertisement/'+u.id} >Редактировать</Link>
                                <button  className="btn btn-danger">Удалить</button>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </div>
    )
}