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

# Output
Raw tokens: ['what', "'", 's', '▁the', '▁weather', '▁like', '▁for', '▁today', '?']
```


## Related Topics
- [[]]