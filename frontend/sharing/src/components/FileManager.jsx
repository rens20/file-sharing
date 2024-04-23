import { useState, useEffect } from 'react';
import axios from 'axios';

const FileManager = () => {
  const [files, setFiles] = useState([]);

  // Fetch files from backend upon component mount
  useEffect(() => {
    const fetchFiles = async () => {
      try {
        const response = await axios.get('http://localhost:8000/files');
        setFiles(response.data.files);
      } catch (error) {
        console.error('Error fetching files:', error);
      }
    };

    fetchFiles();
  }, []);

  const handleRename = async (fileId, newName) => {
    try {
      await axios.put(`http://localhost:8000/files/${fileId}`, { newName });
      // Update files state or display success message
    } catch (error) {
      console.error('Error renaming file:', error);
      // Display error message
    }
  };

  const handleDelete = async (fileId) => {
    try {
      await axios.delete(`http://localhost:8000/files/${fileId}`);
      // Remove file from files state or display success message
    } catch (error) {
      console.error('Error deleting file:', error);
      // Display error message
    }
  };

  return (
    <div className="max-w-lg mx-auto mt-8">
      <h2 className="text-2xl font-bold mb-4">File Manager</h2>
      <div className="grid gap-4">
        {files.map((file) => (
          <div key={file.id} className="flex items-center justify-between bg-white p-4 rounded-lg shadow-md">
            <span className="truncate">{file.name}</span>
            <div className="flex gap-2">
              <button
                onClick={() => handleRename(file.id, prompt('Enter new name:'))}
                className="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded-md focus:outline-none focus:ring focus:ring-blue-500 focus:ring-opacity-50"
              >
                Rename
              </button>
              <button
                onClick={() => handleDelete(file.id)}
                className="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-md focus:outline-none focus:ring focus:ring-red-500 focus:ring-opacity-50"
              >
                Delete
              </button>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
};

export default FileManager;
