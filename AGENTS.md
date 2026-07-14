# Agent Guidelines

## Writing Tests

- For `InputFile|string` parameters, the string must be a file ID, not a URL.

## Preserving Backward Compatibility

- Backward compatibility should be preserved as much as possible.
- A new parameter is always added last (with a default value), regardless of its position in the Bot API docs.
