---
topic: LLM Application Foundations
date: 24-09-2026
tags:
  - ai
  - llm
  - token
preparation-notes:
---
## Tokens
Tokens are the fundamental units of text that the LLM reads and generates. They are also used to calculate the billing and cost. When a user sends the text query, the tokenizer is responsible to convert the text into tokens. In English language, the token is usually of 4 characters but may depend on the model/tokenizer. For example, common words like apple may remain apple even though it's 5 characters.

e.g.

User query: What's the forecast for today?

Tokens: `[what] ['] [s] [ the] [ fore] [cast] [ for] [ today] [?]`

The tokenization may vary from model to model. A model made especially for gaming may keep `[ggwp]` as one token because it's quite common word and will appear frequently in both user text and LLM result.

In the below example, you can check how the tokenizer of your model breaks your input into tokens for the model. Notice how the spaces converted to underscores. Model decides how to tokenize the text.

```python
from dotenv import load_dotenv

# Loading HF_TOKEN.
load_dotenv()

from transformers import AutoTokenizer

def get_tokens(text: str):
	model_id = "google/gemma-4-E4B"
	tokenizer = AutoTokenizer.from_pretrained(model_id);
	tokens = tokenizer.tokenize(text);

	print(f"Raw tokens: {tokens}\n")

user_input = "what's the weather like for today?"
get_tokens(user_input)

user_input = "whats the weather like for today?"
get_tokens(user_input)

user_input = "hehe, ggwp"
get_tokens(user_input)

# Output
Raw tokens: ['what', "'", 's', '▁the', '▁weather', '▁like', '▁for', '▁today', '?']
Raw tokens: ['whats', '▁the', '▁weather', '▁like', '▁for', '▁today', '?']
Raw tokens: ['hehe', ',', '_gg', 'wp']
```


## Context Window
Context window is the maximum number of tokens the model can process in a single request. It may include predefined instructions, conversation history, previously generated output, tools results, documented submitted alongside the original user input.

Why does it matter?
It matters because it acts as memory for the AI. The more, the better. But it can backfire as well due to hallucinations.

In below example, we try to see how the system can compile input/output from various source to
create a context. In this example, we use a jinja file to see how the context looks like. This doesn't dive into the topics such as context management. Various chat application manage context length differently. Some may summarize the user chat history to reduce the size. Some may remove inputs by how outdated they are.

```python
from ollama import chat, ChatResponse
from transformers import AutoTokenizer
from typing import TypedDict, Literal
from dotenv import load_dotenv

""" HF token. """
load_dotenv()

""" Strict typing for the messages to llm. """
class Message(TypedDict):
	role: Literal['system', 'user', 'assistant', 'tool']
	content: str

""" Get token information using native ollama module. """
def info_using_ollama(messages: list[Message]):
	response: ChatResponse = chat(
		model='gemma4:e4b',
		messages=messages
	)

	print(f'The total number of tokens used for prompt: {response['prompt_eval_count']}\n')

def info_using_hf(messages: list[Message]):
	model_id = "google/gemma-4-E4B-it"
	tokenizer = AutoTokenizer.from_pretrained(model_id)

	"""
		google/gemma-4-E4B didn't have a jinja template on hf, so used google/gemma-4-E4B-it's
		jinja file. Noticed jinja template is responsible for converting the all the messages/contexts
		into single text to be processed. Upon researching, llms can be without jinja file and handle
		the messages at the chat or orchestration level.
	"""
	# with open("chat_templates/gemma-4-E4B-it/chat_template.jinja", "r") as file:
	# tokenizer.chat_template = file.read()

	prompt = tokenizer.apply_chat_template(messages, tokenize=False, add_generation_prompt=True)
	tokens = tokenizer.tokenize(prompt)
	token_count = len(tokens)

	print(f"Raw tokens: {tokens}\n")
	print(f'The total number of tokens used for prompt: {token_count}\n')

messages: list[Message] = [
	{'role': 'system', 'content': 'You joke about the user input.'},
	{'role': 'user', 'content': 'Explain content window in LLMs'}
]

info_using_ollama(messages)
info_using_hf(messages)
```
## Related Topics
- [[]]