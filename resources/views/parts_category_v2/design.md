# Augen Pro — Style Reference
> Apple keynote on surgical white — clinical, weightless, electric blue as single accent in monochrome void

**Theme:** light

Augen Pro operates in a clinical-white void anchored by deep charcoal typography and one precise electric blue. The entire system reads as a high-end consumer tech brand: sparse, weight-350 type, pill-shaped interface elements floating in near-infinite negative space, and zero decorative chrome. Color is rationed — blue appears only as functional borders on links and tags, never as fills, giving the interface a cool, instrument-panel quality. The layout breathes vertically with 90+px section gaps and max-width centering, creating an editorial rhythm that treats every section like a spread.

## Tokens — Colors

| Name | Value | Token | Role |
|------|-------|-------|------|
| Off-Black | `#0f1012` | `--color-off-black` | Primary text, hero and footer backgrounds, icon fills |
| Pure Black | `#020201` | `--color-pure-black` | Secondary text, emphasis fills |
| Off-White | `#f2f2f4` | `--color-off-white` | Page canvas |
| Pure White | `#fdfdfd` | `--color-pure-white` | Elevated card surfaces |
| Steel Gray | `#5e5e5e` | `--color-steel-gray` | Muted body text |
| Ash Gray | `#8f8f8f` | `--color-ash-gray` | Tertiary helper text |
| Signal Blue | `#0071e3` | `--color-signal-blue` | Links, tags, interactive borders — never fills |

## Tokens — Typography

PP Neue Montreal substitute: Inter 350/400. Letter-spacing `-0.02em` everywhere. Hierarchy from size, not weight.

| Role | Size | Line Height | Letter Spacing |
|------|------|-------------|----------------|
| caption | 10px | 12 | -0.2px |
| body | 16px | 19.2 | -0.32px |
| subheading | 18px | 21.6 | -0.36px |
| heading | 27px | 32.4 | -0.54px |

## Layout

- Page max-width: `1200px`
- Section gap: `90–100px`
- Card padding: `69px`
- Radii: buttons `26px`, nav `10px`, large cards `54px`, tags `9999px`, body containers `63px`
- No drop shadows — elevation via `#fdfdfd` on `#f2f2f4` and `0.5px` hairlines
- Floating pill nav (not a full-width bar), dark band footer, left-aligned body copy

## Applied to

`parts_category_v2` template only (FANS / infraredsaunafans.com).
