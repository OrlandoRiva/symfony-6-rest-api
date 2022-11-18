import React, {useState} from 'react';
import axios from "axios";
import {Button, Grid, TextField, Typography} from "@mui/material";

export default function () {
    const [name, setName] = useState('');
    const [description, setDescription] = useState('');

    const handleSubmit = (e) => {
        e.preventDefault();

        let formData = new FormData()

        formData.append("name", name);
        formData.append("description", description);

        axios
            .post('https://127.0.0.1:8000/api/project/create', formData)
            .then((res) => {
                console.log(res.data);
            })
            .catch((err) => {
                console.log(err);
            });
    }

    return (
        <>
            <Grid container-fluid>
                <Grid item xs={12} pt={5}>
                    <Typography variant="h6" className="title">
                        Create New Project
                    </Typography>
                </Grid>
                <form onSubmit={handleSubmit}>
                    <Grid item xs={12} pt={5}>
                        <TextField
                            id="outlined-basic"
                            label="name"
                            type="text"
                            name="name"
                            variant="outlined"
                            fullWidth
                            value={name}
                            onChange={(e) => setName(e.target.value)}
                        />
                    </Grid>
                    <Grid item xs={12} pt={5}>
                        <TextField
                            id="outlined-multiline-static"
                            label="Description"
                            type="text"
                            multiline
                            rows={4}
                            fullWidth
                            value={description}
                            onChange={(e) => setDescription(e.target.value)}
                        />
                    </Grid>
                    <Grid item xs={12} pt={5}>
                        <Button type="submit" value="submit" variant="contained" color="success">
                            Save
                        </Button>
                    </Grid>
                </form>
            </Grid>
        </>
    );
}