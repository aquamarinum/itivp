// App.js
import React, { useState, useEffect } from "react";
import SearchBar from "./SearchBar";
import VideoList from "./VideoList";
import VideoDetail from "./VideoDetail";

import "./style.css";

const App = () => {
  const [videos, setVideos] = useState([]);
  const [selectedVideo, setSelectedVideo] = useState(null);
  const [searchTerm, setSearchTerm] = useState("популярное");

  // Replace with your actual YouTube API key
  const API_KEY = "AIzaSyA_AtIULkdJa3jUPYH-33g92qNiMmbpWxs";

  useEffect(() => {
    if (searchTerm) {
      searchVideos(searchTerm);
    }
  }, [searchTerm]);

  const searchVideos = async (term) => {
    try {
      const response = await fetch(
        `https://www.googleapis.com/youtube/v3/search?part=snippet&maxResults=5&q=${term}&key=${API_KEY}&type=video`
      );
      const data = await response.json();

      setVideos(data.items);
      if (data.items.length > 0) {
        setSelectedVideo(data.items[0]); // Select the first video by default
      } else {
        setSelectedVideo(null); // Clear selected video if no results
      }
    } catch (error) {
      console.error("Error fetching videos:", error);
      setVideos([]); // Clear videos on error
      setSelectedVideo(null); // Clear selected video on error
    }
  };

  const handleSearchSubmit = (term) => {
    if (term === "") setSearchTerm("популярное");
    else setSearchTerm(term);
  };

  const handleVideoSelect = (video) => {
    setSelectedVideo(video);
  };

  return (
    <div className="ui container">
      <SearchBar onFormSubmit={handleSearchSubmit} />
      <div className="ui grid">
        <div className="ui row">
          <div className="eleven wide column">
            <VideoDetail video={selectedVideo} />
          </div>
          <div className="five wide column">
            <VideoList videos={videos} onVideoSelect={handleVideoSelect} />
          </div>
        </div>
      </div>
    </div>
  );
};

export default App;
