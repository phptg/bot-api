#!/usr/bin/env python3
"""Convert a saved core.telegram.org page into readable Markdown.

Usage:
    python3 telegram_page_to_md.py <input.html> [output.md]

Works both for https://core.telegram.org/bots/api-changelog and for
https://core.telegram.org/bots/api (the full reference is huge, so the
result is meant to be searched with grep, not read as a whole).
"""

from __future__ import annotations

import html
import re
import sys

BLOCK_END = re.compile(r"</(p|ul|ol|h[1-6]|div|blockquote|table|pre)>", re.IGNORECASE)
TABLE_ROW = re.compile(r"<tr[^>]*>(.*?)</tr>", re.IGNORECASE | re.DOTALL)
TABLE_CELL = re.compile(r"<t[dh][^>]*>(.*?)</t[dh]>", re.IGNORECASE | re.DOTALL)
TAG = re.compile(r"<[^>]+>")


def _clean_cell(cell: str) -> str:
    return " ".join(TAG.sub("", cell).split())


def _convert_row(match: re.Match[str]) -> str:
    cells = [_clean_cell(cell) for cell in TABLE_CELL.findall(match.group(1))]
    if not cells:
        return "\n"
    return "\n| " + " | ".join(cells) + " |\n"


def convert(source: str) -> str:
    marker = '<div id="dev_page_content"'
    start = source.find(marker)
    body = source[start:] if start != -1 else source

    body = re.sub(r"<script.*?</script>", "", body, flags=re.IGNORECASE | re.DOTALL)
    body = re.sub(r"<style.*?</style>", "", body, flags=re.IGNORECASE | re.DOTALL)

    # Anchor icons would otherwise turn into stray emphasis markers.
    body = re.sub(r"<i class=\"anchor-icon\"></i>", "", body, flags=re.IGNORECASE)

    # Keep inline emphasis: Telegram marks field and parameter names with <em>.
    body = re.sub(r"</?(strong|b)>", "**", body, flags=re.IGNORECASE)
    body = re.sub(r"</?(em|i)>", "_", body, flags=re.IGNORECASE)
    body = re.sub(r"</?code>", "`", body, flags=re.IGNORECASE)

    # A table row becomes a single line, so that one field is one grep hit.
    body = TABLE_ROW.sub(_convert_row, body)

    for level in range(1, 7):
        body = re.sub(rf"<h{level}[^>]*>", "\n\n" + "#" * level + " ", body, flags=re.IGNORECASE)
    body = re.sub(r"<li[^>]*>", "\n- ", body, flags=re.IGNORECASE)
    body = re.sub(r"</li>", "", body, flags=re.IGNORECASE)
    body = BLOCK_END.sub("\n", body)
    body = re.sub(r"<br\s*/?>", "\n", body, flags=re.IGNORECASE)

    text = html.unescape(TAG.sub("", body))
    # The anchor icons leave empty emphasis markers behind.
    text = text.replace("____", "").replace("****", "")

    lines = [line.strip() for line in text.splitlines()]
    result: list[str] = []
    for index, line in enumerate(lines):
        if not line:
            if not result or not result[-1]:
                continue
            # Keep list items and table rows packed together.
            following = next((item for item in lines[index + 1:] if item), "")
            for prefix in ("- ", "|"):
                if result[-1].startswith(prefix) and following.startswith(prefix):
                    break
            else:
                result.append(line)
            continue
        result.append(line)
    return "\n".join(result).strip() + "\n"


def main() -> int:
    if len(sys.argv) < 2:
        print(__doc__, file=sys.stderr)
        return 1

    with open(sys.argv[1], encoding="utf-8") as handle:
        text = convert(handle.read())

    if len(sys.argv) > 2:
        with open(sys.argv[2], "w", encoding="utf-8") as handle:
            handle.write(text)
    else:
        sys.stdout.write(text)
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
