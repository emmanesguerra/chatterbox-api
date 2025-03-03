# Chatterbox API  

Chatterbox API is a backend service built with **Laravel** to support real-time chat functionalities. It handles user conversations, processes messages, and integrates with **Gemini AI** for chatbot responses.  

## 🚀 Features  
- **Real-time messaging**
- **AI-powered chatbot** responses using Gemini AI  
- **RESTful API** for managing conversations and messages  
- **Service & Repository pattern** for scalable business logic data handling

## 📚 Project Structure  
The `app/` directory contains the core logic of the Chatterbox API.  

```
app/
│── Http/                 
│   ├── Controllers/            # API controllers for managing chat logic
│   ├── Requests/               # Validation rules for incoming requests
│   ├── Resources/              # Transforms API responses into structured JSON
│
│── Models/                     # Eloquent models representing database entities
│
│── Providers/                  # Laravel service providers for application bindings
│
│── Repositories/               # Implements repository pattern for data access
│   ├── Conversation/           # Handles conversation-related data operations
│   ├── Message/                # Handles messages-related data operations
│
│── Services/                   # Business logic and external service integrations
│   ├── GeminiService/          # Communicates with Gemini AI for chatbot responses
│   ├── ConversationService/    # Handles conversation-related logic
│   ├── MessageService/         # Handles message-related logic
```

## 📌 Requirements  
- **PHP** 8.2 or higher  
- **Laravel** 12  
- **Composer**  
- **MySQL** or any preferred database  
- **Gemini API Key**


## 🛠️ Setup & Installation
### 1️⃣ Clone the repository
   ```sh
   git clone https://github.com/emmanesguerra/chatterbox-api.git
   cd chatterbox-api
   ```

### 2️⃣ Install dependencies  
   ```sh
   composer install
   ```

### 3️⃣ Set up environment variables  
   ```sh
   cp .env.example .env
   ```

### 4️⃣ Generate application key  
   ```sh
   php artisan key:generate
   ```

### 5️⃣ Run database migrations  
   ```sh
   php artisan migrate
   ```

### 6️⃣ Start the development server 
   ```sh
   php artisan serve
   ```

### 🔑 Gemini API Key Requirement  

To use the chatbot features powered by Gemini, you need to provide your own **Gemini API key**.  

#### Steps to Get a Gemini API Key:  
1. Visit the **[Google AI Developer Console](https://aistudio.google.com/)**.  
2. Create or log in to your **Google Cloud account**.  
3. Enable the **Gemini API** and generate an API key.  
4. Add your API key to your `.env` file:  

   ```env
   GEMINI_API_KEY=your_api_key_here


### 📌 API Endpoints  

| Method  | Endpoint                                    | Controller                            | Description                                       |
|---------|---------------------------------------------|---------------------------------------|---------------------------------------------------|
| `POST`  | `/send-message`                             | `ChatController@processMessage`       | Processes a user message and returns a response.  |
| `POST`  | `/conversations-create`                     | `ConversationController@create`       | Creates a new conversation.                       |
| `GET`   | `/conversations`                            | `ConversationController@lists`        | Fetches all conversations.                        |
| `GET`   | `/conversations/{conversation}/messages`    | `ConversationController@fetchMessages`| Retrieves messages for a specific conversation.   |
| `DELETE`| `/conversations/{id}`                       | `ConversationController@destroy`      | Deletes a conversation by ID.                     |

### 👥 Contributors
- [Emmanuelle Esguerra](https://github.com/emmanesguerra)

## 🐜 Disclaimer  
This project is intended for **practice purposes only** and is not recommended for production use.  
