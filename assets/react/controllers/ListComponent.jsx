import React, {useState, useEffect} from 'react';
import axios from 'axios';
import {Box, Button, ButtonGroup, CircularProgress, Grid, Typography} from "@mui/material";
import {DataGrid} from '@mui/x-data-grid';

export default function () {
    const [projects, setProjects] = useState([]);
    const [count, setCount] = useState();
    const [last, setLast] = useState(5);
    const [remove, setRemove] = useState(false);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        axios
            .get(`https://127.0.0.1:8000/api/projects?last=` + last)
            .then((res) => {
                console.log(res.data.projects);
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
                console.log(err);
            })
    }

    return (
        <>
            {loading ? (
                <Box className="loading">
                    <CircularProgress/>
                </Box>
            ) : (
                <Grid container>
                    <Typography variant="h5" pt={5}>Count Projects: {count}</Typography>
                    <Grid item xs={12} pt={3}>
                        <Typography variant="h5" pb={1}>Filter:</Typography>
                        <ButtonGroup variant="contained" aria-label="outlined primary button group">
                            <Button onClick={() => setLast(5)}>5</Button>
                            <Button onClick={() => setLast(10)}>10</Button>
                            <Button value="" onClick={(e) => setLast(e.target.value)}>All</Button>
                        </ButtonGroup>
                    </Grid>
                    <Grid item xs={12} pt={5} align="left">
                        <Typography variant="h6" p={1} className="title">
                            List of Projects
                        </Typography>
                    </Grid>
                    <Grid sx={{width: "100%"}}>
                        <DataGrid
                            autoHeight
                            rows={projects}
                            getRowId={(row) => row.id}
                            columns={columns}
                            pageSize={last ? null : count}
                            rowsPerPageOptions={[5]}
                            initialState={{
                                sorting: {
                                    sortModel: [
                                        {
                                            field: "id",
                                            sort: "desc",
                                        },
                                    ],
                                },
                            }}
                        />
                    </Grid>
                    <Grid item xs={12} pt={3}>
                        <Button variant="contained" color="error" onClick={handleDelete}>DELETE LAST PROJECT</Button>
                    </Grid>
                </Grid>
            )}
        </>
    );
}

const columns = [
    {field: "id"},
    {field: "name", headerName: "Name", minWidth: 130, flex: 1},
    {field: "description", headerName: "Description", minWidth: 130, flex: 1},
    {
        field: "theme", headerName: "Theme", minWidth: 130, flex: 1, valueGetter: (params) => {
            return params.row.theme.name;
        }
    }
];