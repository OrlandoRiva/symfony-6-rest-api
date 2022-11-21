import React, {useState, useEffect} from 'react';
import axios from 'axios';

export default function () {
    const [projects, setProjects] = useState([]);
    const [count, setCount] = useState();
    const [last, setLast] = useState(3);
    const [remove, setRemove] = useState(false);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        axios
            .get(`https://127.0.0.1:8000/api/projects?last=` + last)
            .then((res) => {
                setProjects(res.data.projects);
                setCount(res.data.count)
                setRemove(false);
                setLoading(false);
            })
            .catch((err) => {
                console.log(err);
            });
    }, [last, remove]);

    const handleDelete = () => {
        axios
            .delete(`https://127.0.0.1:8000/api/project/delete`)
            .then((res) => {
                setRemove(true);
            })
            .catch((err) => {
                // console.log(err);
            })
    }

    return (
        <>
            <h1 className="mt-5">React Test</h1>
            <h2 className="mt-5">Count Projects: {count}</h2>
            <h3 className="mt-5">Filter:</h3>
            <div className="btn-group">
                <button className="btn btn-outline-primary" onClick={() => setLast(3)}>3</button>
                <button className="btn btn-outline-primary" onClick={() => setLast(10)}>10</button>
                <button className="btn btn-outline-primary" value="" onClick={(e) => setLast(e.target.value)}>All
                </button>
            </div>
            {!loading && projects.sort((a, b) => a.id > b.id ? 1 : -1).map((project) => (
                <div className="mt-5" key={project.id}>
                    <h1 className="text-capitalize text-success">{project.name} ({project.id})</h1>
                    <p>{project.description}</p>
                    <span className="text-capitalize"><b
                        className="text-secondary">Theme:</b> {project.theme.name}</span>
                </div>
            ))}
            <br/>
            <hr/>
            <button className="btn btn-danger" onClick={handleDelete}>DELETE LAST PROJECT</button>
        </>
    );
}