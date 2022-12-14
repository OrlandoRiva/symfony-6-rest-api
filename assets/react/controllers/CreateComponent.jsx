import React, {useEffect, useState} from 'react';
import axios from "axios";
import {
    Alert,
    Button,
    FormControl,
    Grid,
    Select,
    TextField,
    Typography,
    InputLabel,
    MenuItem,
    Box, CircularProgress
} from "@mui/material";

export default function () {
    const [themes, setThemes] = useState([]);
    const [name, setName] = useState('');
    const [description, setDescription] = useState('');
    const [theme, setTheme] = useState('');
    const [error, setError] = useState('');
    const [loading, setLoading] = useState(true);

    //Get Themes
    useEffect(() => {
        axios
            .get('https://127.0.0.1:8000/api/themes')
            .then((res) => {
                console.log(res.data);
                setThemes(res.data.themes);
                setLoading(false);
            })
            .catch((err) => {
                console.log(err);
            });
    }, []);
    //

    //Post Project
    const handleSubmit = (e) => {
        e.preventDefault();

        let formData = new FormData()

        formData.append('name', name);
        formData.append('description', description);
        formData.append('theme', theme);

        axios
            .post('https://127.0.0.1:8000/api/project/create', formData)
            .then((res) => {
                if (res.status === 201) {
                    console.log(res.data);
                    console.log(res.status);
                    window.location = '/react';
                }
                setError(res.data);
            })
            .catch((err) => {
                console.log(err);
            });
    }
    //

    //Get Theme Value
    const handleChange = (event) => {
        setTheme(event.target.value);
    };
    //

    return (
        <>
            {loading ? (
                <Box className="loading">
                    <CircularProgress/>
                </Box>
            ) : (
                <Grid className="container-fluid">
                    <Grid item xs={12} pt={5}>
                        <Typography variant="h6" className="title">
                            Create New Project
                        </Typography>
                    </Grid>
                    <form onSubmit={handleSubmit}>
                        <Grid item xs={12} pt={5}>
                            <TextField
                                id="outlined-basic"
                                label="Name"
                                type="text"
                                name="name"
                                variant="outlined"
                                fullWidth
                                value={name}
                                onChange={(e) => setName(e.target.value)}
                            />
                            {error.nameError && (
                                <Grid item xs={12} pt={1}>
                                    <Alert variant="filled" severity="error">{error.nameError}</Alert>
                                </Grid>
                            )}
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
                            {error.descriptionError && (
                                <Grid item xs={12} pt={1}>
                                    <Alert variant="filled" severity="error">{error.descriptionError}</Alert>
                                </Grid>
                            )}
                        </Grid>
                        <Grid item xs={12} pt={5}>
                            <FormControl fullWidth>
                                <InputLabel id="demo-simple-select-label">Theme</InputLabel>
                                <Select
                                    labelId="demo-simple-select-label"
                                    id="demo-simple-select"
                                    name="theme"
                                    defaultValue=""
                                    label="Theme"
                                    onChange={handleChange}
                                >
                                    {themes.map((theme) => (
                                        <MenuItem key={theme.id} value={theme.id}>
                                            {theme.name}
                                        </MenuItem>
                                    ))}
                                </Select>
                            </FormControl>
                            {error.themeError && (
                                <Grid item xs={12} pt={1}>
                                    <Alert variant="filled" severity="error">{error.themeError}</Alert>
                                </Grid>
                            )}
                        </Grid>
                        <Grid item xs={12} pt={5}>
                            <Button type="submit" value="submit" variant="contained" color="success">
                                Save
                            </Button>
                        </Grid>
                    </form>
                </Grid>
            )}
        </>
    );
}