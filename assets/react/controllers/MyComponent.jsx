import React, {useState, useEffect} from 'react';
import axios from 'axios';

export default function () {
    const [projects, setProjects] = useState([]);
    const [count, setCount] = useState();
    const [last, setLast] = useState(3);
    const [remove, setRemove] = useState(false);

    useEffect(() => {
        axios
            .get(`https://127.0.0.1:8000/api/projects?last=` + last)
            .then((res) => {
                setProjects(res.data.projects);
                setCount(res.data.count)
                setRemove(false);
            })
            .catch((err) => {
                // console.log(err);
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
            <div>
                <h2>Count {count}</h2>
                <button onClick={() => setLast(3)}>3</button>
                <button onClick={() => setLast(10)}>10</button>
                <button value="" onClick={(e) => setLast(e.target.value)}>All</button>
                {projects.sort((a, b) => a.id > b.id ? 1 : -1).map((project) => (
                    <div key={project.id}>
                        <h1>{project.name} {project.id}</h1>
                        <p>{project.description}</p>
                    </div>
                ))}
                <br/>
                <hr/>
                <button onClick={handleDelete}>DELETE LAST PROJECT</button>
            </div>
        </>
    );
}